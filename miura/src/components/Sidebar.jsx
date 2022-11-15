import { Button,Stack,TextField } from '@mui/material';
import { useForm,Controller } from "react-hook-form";
import CheckForm from "./CheckForm";

function Sidebar() {
  const { control,handleSubmit } = useForm({
    //フォームの初期値
    defaultValues: { name: '寺田心',email:"bookOffnanoniHonNeJan@gmail.com",tel:"080-1237-2124"}
  })
  //フォームのバリデーションルール
  const validationRules = {
    name: {
      required: '名前を入力してください。',
      minLength: { value: 2, message: '2文字以上で入力してください。' }
    },
    email: {
      required: 'メールアドレスを入力してください',
      minLength: { value: 8, message: '8文字以上入力してください'},
      pattern: { value: /^\S+@\S+\.\S+/, message: "正しい書式で記入してください"}
    },
    tel: {
      required: '電話番号を入力してください',
      minLength: { value: 8, message: '8文字以上入力してください'},
      pattern : {value: /^0\d{1,4}-\d{1,4}-\d{3,4}$/,message:"正しい書式で記入してください"}
    }
  }
  //コンソールにフォームの値を表示
  const onSubmit = (data) => {
    Object.values(data).forEach((value) => console.log(value))
  }
  //テキストフィールドの設定の連想配列
  const array = [{english:"name",japanese:"名前"},{english:"email",japanese:"メールアドレス"},{english:"tel",japanese:"電話番号"}];
  //テキストフィールドの配列
  const Texts = array.map((value) =><Controller
  name={value.english}
  control={control}
  rules={validationRules[value.english]}
  render={({ field, fieldState }) => {
    return (
   <TextField
      {...field}
     type="text"
     label={value.japanese}
      error={fieldState.invalid}
      helperText={fieldState.error?.message}
   />
 )}}
/>)
  return (
    <Stack component="form" noValidate 
    onSubmit={handleSubmit(onSubmit)} 
   spacing={2} sx={{ m: 2, width: '25ch' ,padding:4}}>
            {Texts}
            <CheckForm title={"ユーザー区分"} label={[{name:"法人",default:true},{name:"個人事業主",default:false},{name:"個人",default:true}]}></CheckForm>
            <CheckForm title={"ステータス"} label={[{name:"利用停止",default:false},{name:"有効",default:true},{name:"メール認証中",default:false}]}></CheckForm>
            <Button variant="contained" type="submit" color='success'>検索</Button>
    </Stack>
  );
}

export default Sidebar;