import React from 'react';

export default class App extends React.Component {
    /**
     *
     * @returns {JSX}
     */
    render() {
        return (
            <div className="col-md-6 col-md-offset-3">{this.props.children}</div>
        );
    }
}
