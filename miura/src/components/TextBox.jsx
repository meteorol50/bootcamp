import { TextField } from '@mui/material';
function TextBox({register,errors,values}){
    const Texts = values.map((value) =>
    <TextField
        required
        type="text"
        label={value.japanese}
        error={value.english in errors}
        {...register(value.english)}
        helperText={errors[value.english]?.message}
    />
)
return(
    <>
    {Texts}
    </>
    )
}

export default TextBox 