import { Link } from 'react-router-dom';
import Button from '@mui/material/Button';
// import * as z from 'zod';

import { Form, InputField } from 'components/Form';

// const schema = z.object({
//   email: z.string().min(1, 'Required'),
//   password: z.string().min(1, 'Required'),
// });

export function LoginForm(onSuccess) {
  return (
    <div>
      <Form
        onSubmit={async (values) => {
          // await login(values);
          console.log('test', values);
          onSuccess();
        }}
      // schema={schema}
      >
        {({ register, formState }) => (
          <>
            <InputField
              type="email"
              label="Email Address"
              error={formState.errors.email}
              registration={register('email')}
            />
            <InputField
              type="password"
              label="Password"
              error={formState.errors.password}
              registration={register('password')}
            />
            <div>
              <Button isLoading={false} type="submit" className="w-full">
                Log in
              </Button>
            </div>
          </>
        )}
      </Form>
      <div className="mt-2 flex items-center justify-end">
        <div className="text-sm">
          <Link to="../register" className="font-medium text-blue-600 hover:text-blue-500">
            Register
          </Link>
        </div>
      </div>
    </div>
  );
}
