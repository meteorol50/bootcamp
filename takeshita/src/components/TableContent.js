import React, { useState } from "react";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import TableSortLabel from '@mui/material/TableSortLabel';
import TableHeader from "./TableHeader";
import { elementAcceptingRef } from "@mui/utils";
import { IconContext } from "react-icons"
import AccountCircleIcon from '@mui/icons-material/AccountCircle';




const rowInformation = [
    // { "name": "sample1" ,"age": 60},
    // { "name": "sample2" ,"age": 70}
    { "logo":<AccountCircleIcon sx={{ color: '#ccc', fontSize: 30 }}/>,"name": "sample_user1","status": "有効" ,"tel": "0334630041", "mailAddress":"sample_user5@gmail.com", "userSelect":"個人"},
    { "logo":<AccountCircleIcon sx={{ color: '#ccc', fontSize: 30 }}/>,"name": "sample_user4","status": "利用停止" ,"tel": "0334630031", "mailAddress":"sample_user4@gmail.com", "userSelect":"個人"},
    { "logo":<AccountCircleIcon sx={{ color: '#ccc', fontSize: 30 }}/>,"name": "sample_user3","status": "有効" ,"tel": "0334630021", "mailAddress":"sample_user3@gmail.com", "userSelect":"法人"},
    { "logo":<AccountCircleIcon sx={{ color: '#ccc', fontSize: 30 }}/>,"name": "sample_user2","status": "利用停止" ,"tel": "0334630011", "mailAddress":"sample_user2@gmail.com", "userSelect":"法人"},
]

function descendingComparator(a, b, orderBy) {
    
    if(b[orderBy] < a[orderBy]){
        return -1
    }
    if(b[orderBy] > a[orderBy]){
        return 1
    }
    return 0
}

function compare(a,b){
    let index = 0
    let a_num = parseInt(a)
    let b_num = parseInt(b)

    if (a_num > b_num) {
        index = 1
    }else if (a_num < b_num) {
        index = -1
    }
    return index
}

function getComparator(order, orderBy){
    return order === "desc"
    ? (a,b) => descendingComparator(a,b,orderBy)
    : (a,b) => -descendingComparator(a,b, orderBy)
}

const sortedRowInformation = (rowArray, comparator) => {
    const stabilizedRowArray = rowArray.map((el, index) => [el, index])
    stabilizedRowArray.sort((a,b) => {
        const order = comparator(a[0], b[0])
        if(order !==0) return order
        return a[1] - b[1]
    })
        
    return stabilizedRowArray.map((el) => el[0])
}

export default function TableContent() {
    const [orderDirection, setOrderDirection] = useState('asc')
    const [valueToOrderBy, setvalueToOrderBy] = useState('name')
    // const [page, setPage] = useState(0)
    // const [rowsPerPage, setRowsPerPage] = useState(1)

    const handleRequestSort = (event, property) => {
        const isAscending = (valueToOrderBy === property && orderDirection === 'asc')
        setvalueToOrderBy(property)
        setOrderDirection(isAscending ? 'desc' : 'asc')
    }


  return (
    <div>
        <TableContainer>
            <Table sx={{width: '55%' ,position: 'absolute',top: 50,left: '30%'}}>
                <TableHeader 
                    valueToOrderBy={valueToOrderBy}
                    orderDirection={orderDirection}
                    handleRequestSort={handleRequestSort}
                
                />
                {
                    sortedRowInformation(rowInformation, getComparator(orderDirection, valueToOrderBy))
                    .map((person, index) => (
                        <TableRow key={index}>
                            <TableCell>
                                {person.logo}
                            </TableCell>
                            <TableCell>
                                {person.name}
                            </TableCell>
                            {/* <TableCell>
                                {person.tel}
                            </TableCell> */}
                            <TableCell sx={{
                            // padding: "2.5em 1em",
                            // margin: "2.5em",
                            // fontWeight: "bold",
                            // border: "solid 3px #6091d3",/*線*/
                            // borderradius: "10px",/*角の丸み*/    
                            // color:"pink",
                            // backgroundColor:"aqua",
                            }}>
                            {/* <span backgroundColor:"aqua">背景色</span> */}
                                <span style={{
                                border: "solid 0px",
                                color:'purple',
                                backgroundColor:'#FFDDFF',
                                padding: "0.5em 1em",
                                borderRadius: "10px",
                                fontWeight: "bold"
                                }}>{person.status}</span>
                                {/* {person.status} */}
                                {/* <AccountCircleIcon /> */}
                            </TableCell>
                            <TableCell>
                                {person.tel}
                            </TableCell>
                            <TableCell>
                                {person.mailAddress}
                            </TableCell>
                            <TableCell>
                                {person.userSelect}
                            </TableCell>
                        </TableRow>
                    ))
                }
            </Table>
        </TableContainer>
    </div>
  )
}
