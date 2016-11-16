import React from 'react';
import ReactDom from 'react-dom';

import Wrapper from './components/layout/wrapper';
import Header from './components/layout/header';
import Body from './components/layout/body';

import Topic from './components/topic/';

export default function render({ root }) {

  ReactDom.render(
    <Wrapper>
      <Header />
      <Body>

        <Topic />


      </Body>
    </Wrapper>,
    root
  );
}
