import { Button,Stack } from '@mui/material';
import { useForm } from "react-hook-form";
import { yupResolver } from '@hookform/resolvers/yup';
import * as yup from 'yup'
import CheckForm from "./CheckForm";
import TextBox from "./TextBox";

function Sidebar({setValue}) {

// バリデーションルール
const schema = yup.object({
    name: yup.string().required('必須です'),
    email: yup
        .string()
        .required('必須です')
        .email('正しいメールアドレス入力してね')
        .matches(/^\S+@\S+\.\S+/,"正しい書式で記入してください"),
    tel: yup
        .string()
        .required('必須です')
        .min(8, '6文字以上記入してください')
        .matches(
        /^0\d{1,4}-\d{1,4}-\d{3,4}$/,
        '正しい書式で記入してください'
        ),
    })

const { register,handleSubmit,formState: { errors } } = useForm({
    //バリデーションルールをフォームの設定に追加
    resolver: yupResolver(schema),
    //フォームの初期値
    defaultValues: { name: '寺田心',email:"bookOffnanoniHonNeJan@gmail.com",tel:"080-1237-2124" }
})
  //コンソールにフォームの値を表示
const onSubmit = (data) => {
    Object.values(data).forEach((value) => console.log(value));
    setValue(data.name);
}
    return (
    <Stack component="form" noValidate 
    onSubmit={handleSubmit(onSubmit)} 
    spacing={2} sx={{ m: 2, width: '25ch' ,padding:4}}>
        <TextBox register={register} errors={errors} values={[
        {english:"name",japanese:"名前"},
        {english:"email",japanese:"メールアドレス"},
        {english:"tel",japanese:"電話番号"}
        ]}/>
        <CheckForm 
            title={"ユーザー区分"} 
            label={[
                {name:"法人",default:true},
                {name:"個人事業主",default:false},
                {name:"個人",default:true}
                ]} 
        />
        <CheckForm 
            title={"ステータス"} 
            label={[
                {name:"利用停止",default:false},
                {name:"有効",default:true},
                {name:"メール認証中",default:false}
                ]}
        />
            <Button variant="contained" type="submit" color='success'>検索</Button>
    </Stack>
);
}

export default Sidebar;