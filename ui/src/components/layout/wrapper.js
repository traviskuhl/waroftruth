import React from 'react';

import styles from './styles.css';

export default function Wrapper({ children }) {

  console.log(styles);

  return (
    <div className={styles.wrapper}>
      {children}
    </div>
  )
}
