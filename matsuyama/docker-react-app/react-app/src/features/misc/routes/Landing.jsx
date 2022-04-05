import { useNavigate } from 'react-router';

import {
  Grid,
  Stack,
  TextField,
  Typography,
  Button,
  InputLabel,
} from '@mui/material';
// import { useAuth } from '@/lib/auth';

export function Landing() {
  const navigate = useNavigate();
  // const { user } = useAuth();

  const handleStart = () => {
    // if (user) {
    //   navigate('/app');
    // } else {
    navigate('/auth/login');
    // }
  };

  return (
    <>
      <Grid
        container
        columns={{ xs: 4, md: 12 }}
        spacing={2}
        sx={{ mt: 0 }}
        direction="row"
        justifyContent="center"
        alignItems="center"
      >
        <Grid item xs={12} sm={8} sx={{ mt: 1, mb: 1 }}>
          <Typography
            shrink
            htmlFor="bootstrap-input"
            sx={{ borderBottom: 1, borderColor: 'grey.500', color: 'grey.400' }}
            gutterBottom
          >
            ログイン
          </Typography>
        </Grid>
      </Grid>
      <Grid
        container
        columns={{ xs: 4, md: 12 }}
        direction="row"
        justifyContent="center"
        alignItems="center"
        spacing={2}
        sx={{ mt: 0 }}
        className="login"
      >
        <Grid item md={5}>
          <Grid container spacing={2} sx={{ mt: 2 }}>
            <Grid item xs={12}>
              <Grid item sm={6} component="div" sx={{ display: 'flex' }}>
                <InputLabel shrink htmlFor="bootstrap-input">
                  メールアドレス
                </InputLabel>
                <InputLabel
                  shrink
                  htmlFor="bootstrap-input"
                  sx={{ color: '#E55C5C' }}
                >
                  必須
                </InputLabel>
              </Grid>
              <TextField
                required
                fullWidth
                id=""
                autoComplete=""
                placeholder="メールアドレス"
              // {...register('email_id')}
              />
              {/* {errors && errors.email_id ? (
                <Typography shrink htmlFor="bootstrap-input">
                  {errors.email_id?.message}
                </Typography>
              ) : (
                ''
              )} */}
            </Grid>

            <Grid item xs={12}>
              <Grid item sm={6} component="div" sx={{ display: 'flex' }}>
                <InputLabel shrink htmlFor="bootstrap-input">
                  パスワード
                </InputLabel>
                <InputLabel
                  shrink
                  htmlFor="bootstrap-input"
                  sx={{ color: '#E55C5C' }}
                >
                  必須
                </InputLabel>
              </Grid>
              {/* <FormControl variant="outlined">
                <OutlinedInput
                  required
                  fullWidth
                  id="password"
                  autoComplete="off"
                  // inputProps={{ type: "password" }}
                  inputProps={{ maxLength: 30, minLength: 8 }}
                  placeholder="パスワード"
                  // {...register('password')}
                  type={showPassword ? 'text' : 'password'}
                  endAdornment={(
                    <InputAdornment position="end">
                      <IconButton
                        aria-label="toggle password visibility"
                        onClick={handleClickShowPassword}
                        onMouseDown={handleMouseDownPassword}
                        edge="end"
                      >
                        {!showPassword ? <VisibilityOff /> : <Visibility />}
                      </IconButton>
                    </InputAdornment>
                  )}
                />
              </FormControl> */}

              {/* <Typography shrink htmlFor="bootstrap-input">
                {errors.password?.message}
              </Typography> */}
            </Grid>
            {/* <Grid item xs={12} sx={{ m: 0 }}>
              <Stack
                spacing={2}
                xs={12}
                sm={4}
                direction="row"
                justifyContent="center"
                alignItems="center"
                sx={{ m: 0 }}
              >
                <Link
                  onClick={handleForgotPassword}
                  underline="none"
                  sx={{ color: '#E55C5C' }}
                >
                  パスワードを忘れた方
                </Link>
              </Stack>
            </Grid> */}

            <Grid item xs={12} sx={{ m: 0 }}>
              <Stack
                spacing={2}
                xs={12}
                sm={4}
                direction="row"
                justifyContent="center"
                alignItems="center"
                sx={{ m: 0 }}
              >
                <Grid item md={11} xs={12} sm={10}>
                  <Button
                    variant="contained"
                    onClick={handleStart}
                  >
                    ログイン
                  </Button>
                </Grid>
              </Stack>
            </Grid>

            <Grid item xs={12}>
              <Stack
                spacing={2}
                xs={12}
                sm={4}
                direction="row"
                justifyContent="center"
                alignItems="center"
                sx={{ mt: 0 }}
              >
                <Typography
                  shrink
                  htmlFor="bootstrap-input"
                  sx={{ color: 'text.primary' }}
                >
                  まだ会員登録がお済みでない方
                </Typography>
              </Stack>
            </Grid>

            <Grid item xs={12} sx={{ m: 0 }}>
              <Stack
                spacing={2}
                xs={12}
                sm={4}
                direction="row"
                justifyContent="center"
                alignItems="center"
                sx={{ m: 0 }}
              >
                <Grid item md={11} xs={12} sm={10} className="newpage">
                  <Button
                    variant="outlined"
                    color="error"
                    style={{ color: '#999999' }}
                  // onClick={handleNewUser}
                  >
                    新規会員登録
                  </Button>
                </Grid>
              </Stack>
            </Grid>
          </Grid>
        </Grid>
      </Grid>
    </>
  );
}
