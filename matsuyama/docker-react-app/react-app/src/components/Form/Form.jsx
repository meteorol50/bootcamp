// import { zodResolver } from '@hookform/resolvers/zod';
import clsx from 'clsx';
// import { useForm } from 'react-hook-form';
import PropTypes from 'prop-types';

export function Form({
  // onSubmit,
  children,
  className,
  // options,
  id,
  // schema,
}) {
  // const methods = useForm({ ...options, resolver: schema && zodResolver(schema) });
  return (
    <form
      className={clsx('space-y-6', className)}
      // onSubmit={methods.handleSubmit(onSubmit)}
      id={id}
    >
      {/* {children(methods)} */}
      {children()}

    </form>
  );
}

Form.propTypes = {
  id: PropTypes.string,
  className: PropTypes.string,
  children: PropTypes.element,
};

Form.defaultProps = {
  id: '',
  className: '',
  children: null,
};
