import React from 'react';
// import FormGroup from '@mui/material/FormGroup';
// import FormControlLabel from '@mui/material/FormControlLabel';
// import Checkbox from '@mui/material/Checkbox';
import InputBasicInfo from './components/InputBasicInfo';
import UserSelect from './components/UserSelect';
import UserStatus from './components/UserStatus';
import TableHeader from './components/TableHeader';
import TableContent from './components/TableContent';

import "./App.css";


const App = () => {
  return (
    <div className='App'>
      <div className='BasicInfo'>
      <InputBasicInfo />
      </div>
      <div className='BasicTable'>
        {/* <BasicTable /> */}
        <TableContent />
      </div>
    </div>
    
  );
};

export default App;