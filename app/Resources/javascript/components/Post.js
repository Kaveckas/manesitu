import React from 'react';

export class Post extends React.Component {
    /**
     *
     * @constructor
     */
    constructor() {
        super();

        this.state = {};
    }

    /**
     *
     * @returns {JSX}
     */
    render() {
        let { postId } = this.props.params;

        return <h1>Post page {postId}</h1>;
    }
}
