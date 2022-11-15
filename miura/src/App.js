import Sidebar from "./components/Sidebar";
import DataTable from "./components/DataTable";
import {Grid} from '@mui/material';

function App() {
  return (
    <Grid container justifyContent="center" alignContent="center" sx={{width:"100vw",height:"100vh"}}>
      <Sidebar />
      <DataTable />
    </Grid>
  );
}

export default App;
