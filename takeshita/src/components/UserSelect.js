import React from 'react';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import  "./UserSelect.css";

const UserSelect = () => {
  return (
    <FormGroup className='userSelect'>
        <>ユーザー区分</>
        <FormControlLabel control={<Checkbox defaultChecked />} label="法人" />
        <FormControlLabel  control={<Checkbox />} label="個人事業主" />
        <FormControlLabel control={<Checkbox defaultChecked />} label="個人" />
    </FormGroup>
  )
}

export default UserSelect