import React from 'react';
// import FormGroup from '@mui/material/FormGroup';
// import FormControlLabel from '@mui/material/FormControlLabel';
// import Checkbox from '@mui/material/Checkbox';
import InputBasicInfo from './components/InputBasicInfo';
import UserSelect from './components/UserSelect';
import UserStatus from './components/UserStatus';

import "./App.css";


const App = () => {
  return (
    <div className='App'>
      <div className='BasicInfo'>
      <InputBasicInfo />
      </div>
      <div className='User'>
      </div>
    </div>
    
  );
};

export default App;