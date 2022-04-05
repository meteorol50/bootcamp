import clsx from 'clsx';
// import { UseFormRegisterReturn } from 'react-hook-form';
import PropTypes from 'prop-types';

import { FieldWrapper } from './FieldWrapper';

export function InputField(props) {
  const {
    type, label, className, registration, error,
  } = props;
  return (
    <FieldWrapper label={label} error={error}>
      <input
        type={type}
        className={clsx(
          'appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
          className,
        )}
        // eslint-disable-next-line react/jsx-props-no-spreading
        {...registration}
      />
    </FieldWrapper>
  );
}

InputField.propTypes = {
  type: PropTypes.string,
  label: PropTypes.string,
  className: PropTypes.string,
  registration: PropTypes.elementType,
  error: PropTypes.string,
};

InputField.defaultProps = {
  type: 'text',
  label: '',
  className: '',
  registration: null,
  error: '',
};
