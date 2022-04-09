import { useRoutes } from 'react-router-dom';

import * as React from 'react';
import { lazyImport } from 'utils/lazyImport';
import { Login } from 'features/auth';

const { MiscRoutes } = lazyImport(() => import('features/misc'), 'MiscRoutes');

export const miscRoutes = [
  {
    path: '/misc/*',
    element: <div><MiscRoutes /></div>,
  },
];

export function AppRoutes() {
  const commonRoutes = [{ path: '/', element: <div><Login /></div> }];

  const element = useRoutes([...miscRoutes, ...commonRoutes]);

  return <div>{element}</div>;
}
