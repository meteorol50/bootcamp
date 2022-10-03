import React from 'react'
import Box from '@mui/material/Box';
import  "./InputBasicInfo.css";
import { Button, Container, Stack, TextField } from '@mui/material'
import { SubmitHandler, useForm } from 'react-hook-form'
import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'
import { green } from '@mui/material/colors';
import { styled } from '@mui/material/styles';
import UserSelect from './UserSelect';
import UserStatus from './UserStatus';
//バリデーションルール
const schema = yup.object({
  email: yup
    .string()
    .required('必須だよ')
    .email('正しいメールアドレス入力してね'),
  name: yup.string().required('必須だよ'),
  password: yup
    .string()
    .required('必須だよ')
    .min(6, '少ないよ')
    .matches(
      /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&].*$/,
      'パスワード弱いよ'
    ),
  phoneNumber: yup.number()
  .typeError('電話番号として認識できません')
  .positive('負の数は電話番号として使えません')
  .integer('小数は電話番号として使えません')
  .min(8)
  .required('必須だよ')

})

const ColorButton = styled(Button)(({ theme }) => ({
  color: 'white',
  fontWeight:'bold',
  marginLeft: '50px',
  width: '150px',
  backgroundColor: green[500],
  '&:hover': {
    backgroundColor: green[700],
  },
}));

const InputBasicInfo = () => {
  const { register, handleSubmit, formState: {errors}, } = useForm({
      //追加
      resolver: yupResolver(schema),
    })
  
    //フォーム送信時の処理
    const onSubmit = (data) => {
      //バリデーションチェックOKの時に行う処理を追加
      console.log(data)
    }
    return (
      <div className="basicInfoInput">
        {/* <Container maxWidth="sm" sx={{ pt: 3 }}>
        <Stack spacing={3}> */}
          <div className='nameInput'>
            <TextField required
            defaultValue="寺田心"
            label="名前"
            placeholder="名前"
            InputLabelProps={{
              shrink: true,
            }}
            {...register('name')} 
            error={'name' in errors}
            helperText={errors.name?.message}
            // helperText={errors.name && 'おい'}
            />
          </div>

          <div className='mailInput'>
          <TextField
            required
            label="メールアドレス"
            type="email"
            placeholder="メールアドレス"
            InputLabelProps={{
              shrink: true,
            }}
            {...register('email')}
            error={'email' in errors}
            helperText={errors.email?.message}
          />
          </div>
        <div className='telInput'>
          <TextField
            // required
            label="電話番号"
            // type="password"
            placeholder="電話番号"
            InputLabelProps={{
              shrink: true,
            }}
            {...register('phoneNumber')}
            error={'phoneNumber' in errors}
            helperText={errors.phoneNumber?.message}
          />
        </div>
          <UserSelect />
          <UserStatus />
          <ColorButton variant="contained" size='large' onClick={handleSubmit(onSubmit)}>
            検索
          </ColorButton>
          <div></div>
        {/* </Stack>
      </Container> */}
      </div>
    );
};


export default InputBasicInfo;