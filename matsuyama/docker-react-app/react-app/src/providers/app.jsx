import * as React from 'react';
import { ErrorBoundary } from 'react-error-boundary';
import { HelmetProvider } from 'react-helmet-async';
import { BrowserRouter as Router } from 'react-router-dom';
import Button from '@mui/material/Button';

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
    <React.Suspense fallback="loading...">
      <ErrorBoundary FallbackComponent={ErrorFallback}>
        <HelmetProvider>
          <Router>{children}</Router>
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
