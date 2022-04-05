import * as React from 'react';
import { Link } from 'react-router-dom';
// import * as z from 'zod';

import Button from '@mui/material/Button';
import { Form, InputField } from 'components/Form';
// import { useTeams } from 'features/teams';

// const schema = z
//   .object({
//     email: z.string().min(1, 'Required'),
//     firstName: z.string().min(1, 'Required'),
//     lastName: z.string().min(1, 'Required'),
//     password: z.string().min(1, 'Required'),
//   })
//   .and(
//     z
//       .object({
//         teamId: z.string().min(1, 'Required'),
//       })
//       .or(z.object({ teamName: z.string().min(1, 'Required') })),
//   );

export function RegisterForm(onSuccess) {
  // const teamsQuery = useTeams({
  //   config: {
  //     enabled: chooseTeam,
  //   },
  // });

  return (
    <div>
      <Form
        onSubmit={async (values) => {
          // await register(values);
          console.log('test', values);
          onSuccess();
        }}
        // schema={schema}
        options={{
          shouldUnregister: true,
        }}
      >
        {({ register, formState }) => (
          <>
            <InputField
              type="text"
              label="First Name"
              error={formState.errors.firstName}
              registration={register('firstName')}
            />
            <InputField
              type="text"
              label="Last Name"
              error={formState.errors.lastName}
              registration={register('lastName')}
            />
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

            {/* {chooseTeam && teamsQuery.data ? (
              <SelectField
                label="Team"
                error={formState.errors.teamId}
                registration={register('teamId')}
                options={teamsQuery?.data?.map((team) => ({
                  label: team.name,
                  value: team.id,
                }))}
              />
            ) : (
              <InputField
                type="text"
                label="Team Name"
                error={formState.errors.teamName}
                registration={register('teamName')}
              />
            )} */}
            <div>
              <Button isLoading={false} type="submit" className="w-full">
                Register
              </Button>
            </div>
          </>
        )}
      </Form>
      <div className="mt-2 flex items-center justify-end">
        <div className="text-sm">
          <Link to="../login" className="font-medium text-blue-600 hover:text-blue-500">
            Log In
          </Link>
        </div>
      </div>
    </div>
  );
}
