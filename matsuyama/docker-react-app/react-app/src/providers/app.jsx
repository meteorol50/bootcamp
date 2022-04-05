import * as React from 'react';
import { ErrorBoundary } from 'react-error-boundary';
import { HelmetProvider } from 'react-helmet-async';
import { BrowserRouter as Router } from 'react-router-dom';
import Button from '@mui/material/Button';

// import Notifications from 'components/Notifications/Notifications';

import PropTypes from 'prop-types';

function ErrorFallback() {
  return (
    <div
      className="text-red-500 w-screen h-screen flex flex-col justify-center items-center"
      role="alert"
    >
      <h2 className="text-lg font-semibold">エラーが発生しました。</h2>
      <Button className="mt-4" onClick={() => window.location.assign(window.location.origin)}>
        Refresh
      </Button>
    </div>
  );
}

export function AppProvider(props) {
  const { children } = props;

  return (
    <React.Suspense
      fallback={(
        <div className="flex items-center justify-center w-screen h-screen">
          {/* <Spinner size="xl" /> */}
        </div>
      )}
    >
      <ErrorBoundary FallbackComponent={ErrorFallback}>
        <HelmetProvider>
          {/* <Notifications />
      {/* <AuthProvider> */}
          <Router>{children}</Router>
          {/* </AuthProvider> */}
        </HelmetProvider>
      </ErrorBoundary>
    </React.Suspense>
  );
}

AppProvider.propTypes = {
  children: PropTypes.element,
};

AppProvider.defaultProps = {
  children: null,
};
