import { Helmet } from 'react-helmet-async';
// import PropTypes from 'prop-types';

// eslint-disable-next-line react/prop-types
export function Head({ title, description }) {
  return (
    <Helmet
      title={title ? `${title} | Bulletproof React` : undefined}
      defaultTitle="Bulletproof React"
    >
      <meta name="description" content={description} />
    </Helmet>
  );
}

// Head.propTypes = {
//   title: PropTypes.string,
//   description: PropTypes.string,
// };

// Head.defaultProps = {
//   title: '',
//   description: '',
// };
