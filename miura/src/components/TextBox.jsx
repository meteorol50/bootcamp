import {TextField} from '@mui/material';

function TextBox({labels}) {
  const Texts = labels.map((value) => <TextField variant='outlined' label={value} placeholder={value}></TextField>)
  return (
    <> 
        {Texts}
    </>
  );
}

export default TextBox;