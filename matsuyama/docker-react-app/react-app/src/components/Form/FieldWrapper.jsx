import clsx from 'clsx';
import PropTypes from 'prop-types';
import {
  Typography,
} from '@mui/material';

export function FieldWrapper(props) {
  const {
    label, className, error, children,
  } = props;
  return (
    <div>
      <Typography className={clsx('block text-sm font-medium text-gray-700', className)}>
        {label}
        <div className="mt-1">{children}</div>
      </Typography>
      {error?.message && (
        <div role="alert" aria-label={error.message} className="text-sm font-semibold text-red-500">
          {error.message}
        </div>
      )}
    </div>
  );
}

FieldWrapper.propTypes = {
  label: PropTypes.string,
  className: PropTypes.string,
  children: PropTypes.elementType,
  error: PropTypes.string,
};

FieldWrapper.defaultProps = {
  label: '',
  className: '',
  children: null,
  error: '',
};
