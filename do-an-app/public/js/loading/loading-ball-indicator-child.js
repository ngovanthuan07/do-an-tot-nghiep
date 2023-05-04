export function loadingBallIndicatorChildHTML() {
    return `
      <div
           class="loading-ball-indicator-child"
           style="
                      position: absolute;
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      width: 100%;
                      height: 100%;
                      background-color: white;
                      z-index: 9999;
                      opacity: 1;"
       >
           <div style="color: #fec54f" class="la-ball-pulse-sync">
               <div></div>
               <div></div>
               <div></div>
           </div>
       </div>
    `;
}
