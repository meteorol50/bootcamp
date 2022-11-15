import {Grid} from '@mui/material';
import { DataGrid } from '@mui/x-data-grid';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';

//テーブルの見出し
const columns = [
    { field: 'アイコン', headerName: '', width: 130 ,renderCell:(params) => 
    <Grid container justifyContent='center' alignItems='center'>
      <AccountCircleIcon sx={{color: '#ccc', fontSize: 40}}/>
    </Grid>
    },
    { field: '名前', headerName: '名前', width: 200, sortable: true},
    { field: 'ステータス', headerName: 'ステータス', width: 200 },
    { field: '電話番号', headerName: '電話番号', width: 300 },
    { field: 'メールアドレス', headerName: 'メールアドレス', width: 300 },
    { field: 'ユーザー区分', headerName: 'ユーザー区分', width: 200 },
];

//テーブルの値
const rows = [
    { id:1 ,名前: "なおき", ステータス: "有効", 電話番号: "090-2222-1111", メールアドレス: "sample1@gmail.com", ユーザー区分: "個人" },
    { id:2 ,名前: "かんた", ステータス: "メール認証中", 電話番号: "080-3333-2222", メールアドレス: "sample2@gmail.com", ユーザー区分: "法人"},
    { id:3 ,名前: "れい", ステータス: "利用停止", 電話番号: "090-3737-4444", メールアドレス: "sample3@gmail.com", ユーザー区分: "法人" },
    { id:4 ,名前: "もも", ステータス: "メール認証中", 電話番号: "080-7777-2222", メールアドレス: "sample4@gmail.com", ユーザー区分: "個人事業主" },
    { id:5 ,名前: "かれん", ステータス: "有効", 電話番号: "090-4433-2211", メールアドレス: "sample5@gmail.com", ユーザー区分: "法人" },
    { id:6 ,名前: "けんと", ステータス: "メール認証中", 電話番号: "080-5656-7878", メールアドレス: "sample6@gmail.com", ユーザー区分: "個人" },
    { id:7 ,名前: "寺田心", ステータス: "利用停止", 電話番号: "080-1237-2124", メールアドレス: "bookOffnanoniHonNeJan@gmail.com", ユーザー区分: "個人" },
];

function DataTable(){
    return (
        <>
        <DataGrid
          rows={rows}
          columns={columns}
          sx={{height:"50%",fontSize:18,border:"none"}}
        />
      </>
    )
}

export default DataTable;