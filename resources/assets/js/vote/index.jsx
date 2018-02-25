import React from 'react';
import ReactDOM from 'react-dom';
import PageContent from "./PageContent"

let conteiner = document.getElementById('votePageContent');
if(conteiner){
    let roomId = conteiner.getAttribute('data-room')
    ReactDOM.render(   <PageContent roomID={roomId}/>,conteiner);
}



