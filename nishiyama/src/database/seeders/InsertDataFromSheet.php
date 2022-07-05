<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InsertDataFromSheet extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            ini_set('memory_limit', '256M');
            DB::statement("SET foreign_key_checks=0");
            printf("Loading excel table data sheet...");
            $excelFile = IOFactory::load(realpath(getcwd().'/database/seeders/DB_DATA.xlsx'));
            printf(" Done." . PHP_EOL . PHP_EOL);
            $ignoreTables = [
                'migrations', 'oauth_access_tokens', 'oauth_auth_codes', 'oauth_clients', 'oauth_personal_access_clients',
                'oauth_refresh_tokens'
            ];
            $tables = DB::select("SHOW TABLES;");
            $databaseName = env('DB_DATABASE');
            $tables = array_map(function ($obj) use ($databaseName) {
                $key = "Tables_in_{$databaseName}";
                return $obj->$key;
            }, $tables);
            $tables = array_diff($tables, $ignoreTables);
            $invalidDataTables = [];
            $tables = ['prefectures'];
            foreach ($tables as $table) {
                printf("Reading data for table: {$table}...");
                $data = $excelFile->getSheetByName($table);
                if ($data) {
                    $data = $data->getRowIterator();
                } else {
                    printf(" Not Found." . PHP_EOL);
                    continue;
                }
                printf(" Done." . PHP_EOL);
                $rows = [];
                foreach ($data as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    $cells = [];
                    foreach ($cellIterator as $cell) {
                        $cell = $cell->getFormattedValue();
                        if (is_object($cell)) {
                            $cells[] = $cell->getPlainText();
                        } else {
                            $cells[] = $cell;
                        }
                    }
                    $rows[] = $cells;
                }
                $columns = reset($rows);
                $arrayPointer = 0;
                $columns = array_filter($columns);
                while (!$this->allStringsAreEnglish($columns)) {
                    $columns = next($rows);
                    $arrayPointer++;
                    $columns = array_filter($columns);
                }
                $rows = array_splice($rows, $arrayPointer + 1);
                $rows = array_filter($rows, 'array_filter');
                if (empty($rows)) {
                    continue;
                }
                $tableDesc = DB::select("DESC {$table}");
                $defaultValues = [];
                foreach ($tableDesc as $columnDesc) {
                    if ($columnDesc->Null == 'NO' && is_null($columnDesc->Default)) {
                        continue;
                    }
                    $defaultValues[$columnDesc->Field] = $columnDesc->Default;
                }
                $tableData = [];
                printf("Validating & creating table data array" . PHP_EOL);
                foreach ($rows as $row) {
                    $data = [];
                    foreach ($columns as $columnIndex => $columnName) {
                        if ((empty($row[$columnIndex]) || is_null($row[$columnIndex])) && isset($defaultValues[$columnName])) {
                            if ($defaultValues[$columnName] == 'CURRENT_TIMESTAMP') {
                                $data[$columnName] = now();
                            } else {
                                $data[$columnName] = $defaultValues[$columnName];
                            }
                            continue;
                        }
                        if ($row[$columnIndex] == 'SYSDATE()' || $columnName == 'created_at' || $columnName == 'updated_at') {
                            $data[$columnName] = now();
                        } else {
                            $data[$columnName] = $row[$columnIndex];
                        }
                    }
                    if (!$this->isValidTableData($table, $data)) {
                        printf("Invalid table data detected for table: {$table}. Skipping..." . PHP_EOL . PHP_EOL);
                        array_push($invalidDataTables, $table);
                        continue 2;
                    }
                    array_push($tableData, $data);
                }
                printf("Truncating table" . PHP_EOL);
                DB::table($table)->truncate();
                printf("Inserting " . number_format(count($tableData)) . " values into table (1,000 at a time)...");
                foreach (array_chunk($tableData, 1000) as $t) {
                    DB::table($table)->insert($t);
                }
                printf(" Done" . PHP_EOL);
                printf("Values inserted to table: {$table}" . PHP_EOL . PHP_EOL);
            }
            DB::statement("SET foreign_key_checks=1");
            if (!empty($invalidDataTables)) {
                printf("Tables with invalid data in sheet: " . implode(', ', $invalidDataTables) . PHP_EOL);
            }
        } catch (Exception $error) {
            printf($error->getMessage() . PHP_EOL);
            DB::statement("SET foreign_key_checks=1");
        }
    }

    /**
     * Check if a string has only english characters
     * @param string $str
     * @return bool
     */
    function isEnglish(string &$str)
    {
        if (strlen($str) != strlen(utf8_decode($str))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check column names for english characters
     * @param array $columns
     * @return bool
     */
    function allStringsAreEnglish(array &$columnNames)
    {
        foreach ($columnNames as $columnName) {
            if (!$this->isEnglish($columnName)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate data for table
     * @param string $tableName
     * @param array $tableData
     * @return bool
     */
    function isValidTableData(string &$tableName, array &$tableData)
    {
        $tableDesc = DB::select("DESC {$tableName}");
        $rules = [];
        foreach ($tableDesc as $columnDesc) {
            $rule = [];
            if ($columnDesc->Null == 'NO' && is_null($columnDesc->Default)) {
                array_push($rule, 'required');
            } else {
                array_push($rule, 'nullable');
            }
            // can add more validation rules
            $rules[$columnDesc->Field] = $rule;
        }
        $validator = Validator::make($tableData, $rules);
        return !$validator->fails();
    }
}
