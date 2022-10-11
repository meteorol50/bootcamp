import React from "react";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import TableSortLabel from '@mui/material/TableSortLabel';

export default function TableHeader(props) {

    const {valueToOrderBy, orderDirection, handleRequestSort} = props

    const createSortHandler = (property) => (event) => {
        handleRequestSort(event, property)
    }

    return(
        <TableHead>
            <TableRow>
                <TableCell>
                    
                </TableCell>

                <TableCell key="name">
                    <TableSortLabel
                        active={valueToOrderBy === "name"}
                        direction={valueToOrderBy === "name" ? orderDirection: 'asc'}
                        onClick={createSortHandler("name")}
                        >
                        名前
                    </TableSortLabel>
                </TableCell>

                {/* <TableCell key="age">
                    <TableSortLabel
                        active={valueToOrderBy === "age"}
                        direction={valueToOrderBy === "age" ? orderDirection: 'asc'}
                        // onClick={createSortHandler("age")}
                        >
                        年齢
                    </TableSortLabel>
                </TableCell> */}
                <TableCell>
                    ステータス
                </TableCell>
                <TableCell>
                    電話番号
                </TableCell>
                <TableCell>
                    メールアドレス
                </TableCell>
                <TableCell>
                    ユーザー区分
                </TableCell>
                

            </TableRow>
        </TableHead>
    )
}