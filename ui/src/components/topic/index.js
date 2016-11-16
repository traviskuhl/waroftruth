import React, { Component } from 'react';

import styles from './style.css';

export default class Topic extends Component {

  render() {
    return (
      <section className={styles.wrapper}>
        <h1 className={styles.title}><a href=''>That Climate change is real and man made.</a></h1>

          <p>
            <strong>Abstract</strong>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

          <div className={styles.affermative}>
            <h2>Affermative</h2>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>

          </div>

          <div className={styles.negative}>
            <h2>Negative</h2>
          </div>

      </section>
    )
  }
}
