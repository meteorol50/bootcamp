import { Checkbox,FormControlLabel,FormGroup } from '@mui/material';

function CheckForm({title,label}) {
  //チェックボックスの配列
  const check = label.map((value) => value.default ? 
  <FormControlLabel control={<Checkbox defaultChecked/>} label={value.name} />:
  <FormControlLabel control={<Checkbox/>} label={value.name} />)
  return (
    <FormGroup>
        <p>{title}</p>
        {check}
    </FormGroup>
  );
}

export default CheckForm;
