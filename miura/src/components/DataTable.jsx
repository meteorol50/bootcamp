import { Grid } from '@mui/material';
import { DataGrid } from '@mui/x-data-grid';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';

function DataTable({values}){
    //テーブルの見出し
const columns = [
    { field: 'アイコン', headerName: '', width: 130 ,renderCell:(params) => 
    <Grid container justifyContent='center' alignItems='center'>
        <AccountCircleIcon sx={{color: '#ccc', fontSize: 40}} />
    </Grid>
    },
    { field: 'name', headerName: '名前', width: 200},
    { field: 'status', headerName: 'ステータス', width: 200 },
    { field: 'tel', headerName: '電話番号', width: 300 },
    { field: 'email', headerName: 'メールアドレス', width: 300 },
    { field: 'division', headerName: 'ユーザー区分', width: 200 },
];

//テーブルの値
const rowsData = [
    { id:1 ,name: "なおき", status: "有効", tel: "090-2222-1111", email: "sample1@gmail.com", division: "個人" },
    { id:2 ,name: "かんた", status: "メール認証中", tel: "080-3333-2222", email: "sample2@gmail.com", division: "法人"},
    { id:3 ,name: "れい", status: "利用停止", tel: "090-3737-4444", email: "sample3@gmail.com", division: "法人" },
    { id:4 ,name: "もも", status: "メール認証中", tel: "080-7777-2222", email: "sample4@gmail.com", division: "個人事業主" },
    { id:5 ,name: "かれん", status: "有効", tel: "090-4433-2211", email: "sample5@gmail.com", division: "法人" },
    { id:6 ,name: "けんと", status: "メール認証中", tel: "080-5656-7878", email: "sample6@gmail.com", division: "個人" },
    { id:7 ,name: "寺田心", status: "利用停止", tel: "080-1237-2124", email: "bookOffnanoniHonNeJan@gmail.com", division: "個人" },
];
const rows = rowsData.filter((value,index) => values ? value.name === values : index > -1)
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