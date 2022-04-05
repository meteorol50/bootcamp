import { useRoutes } from 'react-router-dom';

import * as React from 'react';
import { Landing } from '../features/misc';

// import { protectedRoutes } from './protected';
import { publicRoutes } from './public';

export function AppRoutes() {
  const commonRoutes = [{ path: '/', element: <div><Landing /></div> }];

  // const routes = auth.user ? protectedRoutes : publicRoutes;
  const routes = publicRoutes;

  const element = useRoutes([...routes, ...commonRoutes]);

  return <div>{element}</div>;
}
