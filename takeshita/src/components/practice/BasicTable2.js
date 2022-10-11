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

function createData(number, item, qty, name) {
    return { number, item, qty, name };
  }
  
  const rows = [
    createData(1, "Apple", 5, "sample_user225"),
    createData(2, "Orange", 2, "sample_user24"),
    createData(2, "Orange", 2, "sample_user3"),
    // createData(3, "Grapes", 3, 1),
    // createData(4, "Tomato", 2, 1.6),
    // createData(5, "Mango", 1.5, 4)
  ];
  
  export default function SortedTable() {
    const [rowData, setRowData] = useState(rows);
    const [orderDirection, setOrderDirection] = useState("asc");
  
    const sortArray = (arr, orderBy) => {
      switch (orderBy) {
        case "asc":
        default:
          return arr.sort((a, b) =>
            // const a_number = a.name.replace(/[^0-9]/g, ''),
            // const b_number = b.name.replace(/[^0-9]/g, ''),
            Number(a.name.replace(/[^0-9]/g, '')) > Number(b.name.replace(/[^0-9]/g, '')) ? 1 : Number(b.name.replace(/[^0-9]/g, '')) > Number(a.name.replace(/[^0-9]/g, '')) ? -1 : 0
            );
            
        case "desc":
          return arr.sort((a, b) =>
            Number(a.name.replace(/[^0-9]/g, '')) < Number(b.name.replace(/[^0-9]/g, '')) ? 1 : Number(b.name.replace(/[^0-9]/g, '')) < Number(a.name.replace(/[^0-9]/g, '')) ? -1 : 0
          );
      }
    };
  
    const handleSortRequest = () => {
      setRowData(sortArray(rows, orderDirection));
      setOrderDirection(orderDirection === "asc" ? "desc" : "asc");
    };
  
    return (
      <TableContainer component={Paper}>
        <Table aria-label="simple table">
          <TableHead>
            <TableRow>
              <TableCell align="center">S.No</TableCell>
  
              <TableCell align="center">Item</TableCell>
  
              <TableCell align="center">Quantity&nbsp;(kg)</TableCell>
  
              <TableCell align="center" onClick={handleSortRequest}>
                <TableSortLabel active={true} direction={orderDirection}>
                  Price&nbsp;($)
                </TableSortLabel>
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {rowData.map((row) => (
              <TableRow key={row.number}>
                <TableCell component="th" scope="row" align="center">
                  {row.number}
                </TableCell>
                <TableCell align="center">{row.item}</TableCell>
                <TableCell align="center">{row.qty}</TableCell>
                <TableCell align="center">{row.name}</TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    );
  }
  