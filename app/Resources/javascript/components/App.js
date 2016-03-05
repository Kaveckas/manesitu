import React from 'react';

export default class App extends React.Component {
    /**
     *
     * @returns {JSX}
     */
    render() {
        return (
            <div>{this.props.children}</div>
        );
    }
}
