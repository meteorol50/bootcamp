import { useNavigate } from 'react-router-dom';

import { LoginForm } from '../components/LoginForm';
import { Layout } from '../components/Layout';

export function Login() {
  const navigate = useNavigate();

  return (
    <Layout title="Log in to your account">
      <LoginForm onSuccess={() => navigate('/app')} />
    </Layout>
  );
}
