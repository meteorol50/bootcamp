import {Button,Stack} from '@mui/material';
import CheckForm from "./CheckForm";
import TextBox from './TextBox';

function Sidebar() {
  return (
        <Stack spacing={3} sx={{
        width:1/8,padding:4
        }}>
            <TextBox labels={["名前","メールアドレス","電話番号"]}></TextBox>
            <CheckForm title={"ユーザー区分"} label={[{name:"法人",default:true},{name:"個人事業主",default:false},{name:"個人",default:true}]}></CheckForm>
            <CheckForm title={"ステータス"} label={[{name:"利用停止",default:false},{name:"有効",default:true},{name:"メール認証中",default:false}]}></CheckForm>
            <Button variant='contained' color='success'>検索</Button>
        </Stack>
  );
}

export default Sidebar;