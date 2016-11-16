import React from 'react';

import styles from './styles.css';

export default function Body({ children }) {

  return (
    <div className={styles.body}>
      <div className={styles.body_container}>{children}</div>
    </div>
  )
}
