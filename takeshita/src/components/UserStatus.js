import React from 'react';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import './UserStatus.css';

const UserStatus = () => {
  return (
    <FormGroup className='userStatus'>
        <>ユーザーステータス</>
        <FormControlLabel control={<Checkbox defaultChecked />} label="利用停止" />
        <FormControlLabel  control={<Checkbox />} label="有効" />
        <FormControlLabel control={<Checkbox defaultChecked />} label="メール認証中" />
      </FormGroup>
  );
};

export default UserStatus;