<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\CustomResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CustomResponse;

    const LIMIT = 50;
    const OFFSET = 0;
    const QUALITY_RANKS = [
        'A' => 1,
        'B' => 2,
        'C' => 3
    ];

    /**
     * Get parsed quality rank values from request
     * @param string|array $qualityRanks
     * @return array
     */
    public function parseQualityRanks(string|array $qualityRanks)
    {
        if (is_string($qualityRanks)) {
            $qualityRanks = explode(',', $qualityRanks);
        }
        $qualityRanks = array_map(function ($rank) {
            return self::QUALITY_RANKS[$rank];
        }, $qualityRanks);
        return $qualityRanks;
    }

    /**
     * Convert quality ranks using CASE for sql query
     * @param string $compareField
     * @param string $outputField
     * @return string|void
     */
    public function getQualityRanksSqlCaseStatement(string $compareField = 'items.quality_rank', string $outputField = 'quality_rank')
    {
        if (!empty(self::QUALITY_RANKS)) {
            $statement = 'CASE ';
            foreach (self::QUALITY_RANKS as $rank => $value) {
                $statement .= "WHEN {$compareField}={$value} THEN \"{$rank}\" ";
            }
            $statement .= "END AS {$outputField}";
            return $statement;
        }
    }

    /**
     * Get data from url
     * @param string $url
     * @param array $params
     * @param string $method (GET|POST)
     * @param string $returnType (text|json)
     * @return array
     */
    public function getDataFromUrl(string &$url, array &$params = null, string $method = 'GET', string $returnType = 'text')
    {
        if ($method == 'GET' || $method == 'get') {
            $response = Http::get($url, $params);
        } elseif ($method == 'POST' || $method == 'post') {
            $response = Http::post($url, $params);
        }
        return [
            'status' => $response->ok(),
            'statusCode' => $response->status(),
            'content' => strtolower($returnType) == 'json' ? $response->json() : $response->body()
        ];
    }

    /**
     * Generate amazon s3 url
     * @param string $filePath
     * @return string
     */
    public function generateAwsPath(string $filePath = null)
    {
        $url = 'https://' . env('AWS_BUCKET') . '.s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/';
        if ($filePath) {
            $url .= $filePath;
        }
        return $url;
    }

    /**
     * Get aws uri concatenated sql select statement field
     * @param string $column
     * @param string $outputField
     * @param string $filePath
     * @return string
     */
    public function getAwsUriAddedLink(string $column, string $outputField, string $filePath = null)
    {
        return "CONCAT(\"{$this->generateAwsPath($filePath)}\", {$column}) as {$outputField}";
    }

    /**
     * Get validation rules & object
     * @param array $data (data which needs to be validated)
     * @param array $rules (validations rules)
     * @param array $messages (if there is any custom validation messages)
     * @return array|object array: (validation rules) | object: (Validator)
     */
    public function validator(array $input, array $rules, array $messages = [])
    {
        if (count($messages) > 0) {
            // if custom messages are present, returning validator object with custom messages
            return Validator::make($input, $rules, $messages);
        }
        // returning validator object
        return Validator::make($input, $rules);
    }

    /**
     * For sending mail using sendgrid
     * Send an Email to a Single Recipient
     *
     * @param mixed data
     * @param $attachment (file path)
     * @return response
     */
    public function sendSendgridMail($template_id, $toEmailIds, $emailBodyArray, $ccEmailIds = null, $attachment = null)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $email->addTos($toEmailIds);
        if (!empty($ccEmailIds)) {
            foreach ($ccEmailIds as $emailId) {
                $email->addCc($emailId);
            }
        }
        $email->addDynamicTemplateDatas($emailBodyArray);
        if ($attachment) {
            $email->addAttachment(base64_encode(file_get_contents($attachment)), null, basename($attachment));
        }
        $email->setTemplateId($template_id);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        return $sendgrid->send($email);
    }

    /**
     * Resize image
     * @param \Intervention\Image\Image $image
     * @return void
     */
    public function resizeImage(Image &$image)
    {
        $height = $image->getHeight();
        $width = $image->getWidth();
        if ($height == $width) {
            $image->resize(400, 400);
        } else {
            if ($width < $height) {
                $image->resize(400, 400 * $height / $width);
            } elseif ($height < $width) {
                $image->resize($width * 400 / $height, 400);
            }
        }
    }

    /**
     * Generate join query based on array
     * @param array $joinsInfo
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @return void
     * $joinInfo format:
     * $joinsInfo = [
     *      'cars_info' => ['leftJoin', [['items.cars_info_id', '=', 'cars_info.id']], ['cars_info.status' => 1]]
     *      'car_models' => ['join', [['cars_info.car_model_id', '=', 'car_models.id']]]
     *  ];
     */
    public function generateJoinQuery(array &$joinsInfo, Builder|QueryBuilder &$query)
    {
        foreach ($joinsInfo as $table => $joinInfo) {
            if ($joinInfo[0] == 'leftJoin') {
                $query->leftJoin($table, function ($join) use ($joinInfo) {
                    foreach ($joinInfo[1] as $joinCondition) {
                        $join->on($joinCondition[0], $joinCondition[1], $joinCondition[2]);
                    }
                    if (isset($joinInfo[2])) {
                        $join->where($joinInfo[2]);
                    }
                });
            } else {
                $query->join($table, function ($join) use ($joinInfo) {
                    foreach ($joinInfo[1] as $joinCondition) {
                        $join->on($joinCondition[0], $joinCondition[1], $joinCondition[2]);
                    }
                    if (isset($joinInfo[2])) {
                        $join->where($joinInfo[2]);
                    }
                });
            }
        }
    }

    /**
     * Add where equals conditions to query
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param array $whereInfo
     * @return void
     */
    public function addWhereEqualsDataToQuery(Builder|QueryBuilder &$query, array &$whereInfo = null)
    {
        if (!is_null($whereInfo) && !empty($whereInfo)) {
            $whereInArray = array_filter($whereInfo, function ($element) {
                return is_array($element) && !empty($element);
            });
            $whereOnlyData = !empty($whereInArray) ? Arr::except($whereInfo, array_keys($whereInArray)) : $whereInfo;
            $whereOnlyData = array_filter($whereOnlyData);
            $query->where($whereOnlyData)->when(!empty($whereInArray), function ($q) use ($whereInArray) {
                foreach ($whereInArray as $key => $values) {
                    $q->whereIn($key, $values);
                }
                return $q;
            });
        }
    }

    /**
     * Add conditional wheres to query
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param array $conditionalWhereInfo
     * @return void
     */
    public function addConditionalWhereDataToQuery(Builder|QueryBuilder &$query, array &$conditionalWhereInfo = null)
    {
        if (!is_null($conditionalWhereInfo) && !empty($conditionalWhereInfo)) {
            foreach ($conditionalWhereInfo as $element) {
                if (is_array($element[2])) {
                    if (!empty($element[2])) {
                        if ($element[1] == '!=' || $element[2] == '=!') {
                            $query->whereNotIn($element[0], $element[2]);
                        } elseif ($element[1] == '[]') {
                            $query->whereBetween($element[0], $element[2]);
                        } elseif ($element[1] == '![]' || $element[1] == '[]!') {
                            $query->whereNotBetween($element[0], $element[2]);
                        } elseif ($element[1] == '=') {
                            $query->whereIn($element[0], $element[2]);
                        }
                    }
                } else {
                    if (!is_null($element[2])) {
                        $query->where($element[0], $element[1], $element[2]);
                    }
                }
            }
        }
    }
}
