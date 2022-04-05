import { AppProvider } from 'providers/app';
import { AppRoutes } from 'routes';
import * as React from 'react';

function App() {
  return (
    <AppProvider>
      <AppRoutes />
    </AppProvider>
  );
}

export default App;
