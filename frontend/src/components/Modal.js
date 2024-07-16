import React from 'react';

export default function Modal ({ show, title, children, onClose = ()=>{} }) {
    if (!show) return null;

    return (
        <div className = "modal" style = {{display: 'block'}} tabIndex = "-1" role = "dialog" >
            <div className = "modal-dialog" role = "document" >
                <div className = "modal-content" >
                    <div className = "modal-header" >
                        <h5 className = "modal-title font-bold text-lg" >{title}</h5 >
                        <button type = "button" className = "close" onClick = {onClose} aria-label = "Close" >
                            <span aria-hidden = "true" >&times;</span >
                        </button >
                    </div >
                    <div className = "modal-body" >
                        {children}
                    </div >
                </div >
            </div >
        </div >
    );
};