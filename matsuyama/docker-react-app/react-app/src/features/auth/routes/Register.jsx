import { useNavigate } from 'react-router-dom';

import * as React from 'react';
import { RegisterForm } from '../components/RegisterForm';
import { Layout } from '../components/Layout';

export function Register() {
  const navigate = useNavigate();

  return (
    <Layout title="Register your account">
      <RegisterForm onSuccess={() => navigate('/app')} />
    </Layout>
  );
}
