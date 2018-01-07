import React, { Component } from 'react';
import { render } from 'react-dom';

class HelloWorld extends Component {
    render() {
        return (
            <h1>Hello world!</h1>
        );
    }
}

render(<HelloWorld/>, document.getElementById('hello-world-container'));