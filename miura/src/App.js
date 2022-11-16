import Sidebar from "./components/Sidebar";
import DataTable from "./components/DataTable";
import { Grid } from '@mui/material';
import { useState } from "react";

function App() {
  const [value, setValue] = useState("")
  return (
    <Grid container justifyContent="center" alignContent="center" sx={{width:"100vw",height:"100vh"}}>
      <Sidebar setValue = {setValue}/>
      <DataTable values={value}/>
    </Grid>
  );
}

export default App;
