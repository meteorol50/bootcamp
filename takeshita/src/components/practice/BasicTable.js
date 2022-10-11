import React, { useState } from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import TableSortLabel from '@mui/material/TableSortLabel';
import "./BasicTable.css";
import { positions} from '@mui/system';

function createData(name, calories, fat, carbs, protein) {
  return { name, calories, fat, carbs, protein };
}

const rows = [
  createData('Frozen yoghurt', 159, 6.0, 24, 4.0),
  createData('Ice cream sandwich', 237, 9.0, 37, 4.3),
  // createData('Eclair', 262, 16.0, 24, 6.0),
  // createData('Cupcake', 305, 3.7, 67, 4.3),
  // createData('Gingerbread', 356, 16.0, 49, 3.9),
];

export default function BasicTable() {
  return (
    <TableContainer component={Paper} textalign="right">
      <Table sx={{width: '55%' ,position: 'absolute',top: 50,left: '30%'}} aria-label="simple table">
        <TableHead>
          <TableRow>
            <TableCell sx={{color: 'aqua',fontWeight: 'bold'}}>
              <TableSortLabel active='true'>名前</TableSortLabel>
              {/* /* 名前 */}
            </TableCell>
            <TableCell defaultSort='asc' align="right" sx={{color: 'aqua',fontWeight: 'bold'}}>ステータス</TableCell>
            <TableCell align="right" sx={{color: 'aqua',fontWeight: 'bold'}}>電話番号</TableCell>
            <TableCell align="right" sx={{color: 'aqua',fontWeight: 'bold'}}>メールアドレス</TableCell>
            <TableCell align="right" sx={{color: 'aqua',fontWeight: 'bold'}}>ユーザー区分</TableCell>
          </TableRow>
        </TableHead>
        <TableBody className='Basic'>
          {rows.map((row) => (
            <TableRow
              // key={row.name}
              // sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
            >
              <TableCell component="th" scope="row">
                {row.name}
              </TableCell>
              <TableCell align="right">{row.calories}</TableCell>
              <TableCell align="right">{row.fat}</TableCell>
              <TableCell align="right">{row.carbs}</TableCell>
              <TableCell align="right">{row.protein}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}
