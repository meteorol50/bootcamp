import * as React from 'react';
import { DataGrid } from '@mui/x-data-grid';
import "./BasicTable.css";
const columns = [
  { field: 'id', headerName: 'ID', width: 70 ,color: 'aqua',fontWeight: 'bold'},
  { field: 'firstName', headerName: '名前', width: 130},
  { field: 'lastName', 
    headerName: 'ステータス', 
    width: 130,
    disableSelectionOnClick: 'True',
    display: 'none',
    headerBorder: 'none',
    sortable: false,
    disableColumnFilter: 'true',
 },
  {
    field: 'age',
    headerName: '電話番号',
    headerClassName: 'super-app-theme--header',
    headerAlign: 'left',
    align: 'left',
    type: 'number',
    width: 90,
    sortable: false,
  },
  {
    field: 'fullName',
    headerName: 'メールアドレス',
    description: 'This column has a value getter and is not sortable.',
    sortable: false,
    width: 160,
    valueGetter: (params) =>
      `${params.row.firstName || ''} ${params.row.lastName || ''}`,
  },
  {
    field: 'userStatus',
    headerName: '区分',
    type: 'number',
    width: 90,
    sortable: false,
    
  },
];

const rows = [
  { id: 1, lastName: 'Snow', firstName: 'sample1', age: 35 },
  { id: 2, lastName: 'Lannister', firstName: 'sample2', age: 42 },
  { id: 3, lastName: 'Lannister', firstName: 'sample3', age: 45 },
  { id: 4, lastName: 'Stark', firstName: 'sample4', age: 16 },
  { id: 5, lastName: 'Targaryen', firstName: 'sample5', age: null },
  { id: 6, lastName: 'Melisandre', firstName: 'sample7', age: 150 },
  { id: 7, lastName: 'Clifford', firstName: 'sample8', age: 44 },
  { id: 8, lastName: 'Frances', firstName: 'sample9', age: 36 },
  { id: 9, lastName: 'Roxie', firstName: 'sample10', age: 65 },
];

export default function DataTable() {
  return (
    <div style={{ height: 400, width: '100%' }}>
      <DataGrid
        initialState={{
            sorting: {
              sortModel: [{ field: 'firstName', sort: 'desc' }],  
            },
        }}
        sx={{width: '55%',
        position: 'absolute',
        top: 50,left: '30%',
        border: 'none',
        }}
        rows={rows}
        columns={columns}
        // pageSize={5}
        rowsPerPageOptions={[5]}
        // checkboxSelection
      />
    </div>
  );
}
