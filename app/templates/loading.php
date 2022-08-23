<style>
    .absolute-centered {
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
        width: fit-content;
        height: fit-content;
        margin: auto;
        position: absolute;
    }
    
    .loading-cover {
        width: 100%;
        height: 100%;
        position: absolute;
        background-color: var(--back);
        z-index: 10;
    }
    
    .loading-cover > img {
        left: 0;
        width: 90px;
        right: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        height: fit-content;
        margin: auto;
    }
    
    .loader {
        width: 90px;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-evenly;
        bottom: unset;
				top: 120px;
    }
    
    .loader > span {
        font-size: 17px;
        margin: auto;
        color: #a4a4a4;
    }
    
    .loader > div {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: var(--pink);
        animation: bounce .5s alternate infinite;
    }
    
    .loader > div:nth-child(2) {
        animation-delay: .16s;
    }
    
    .loader > div:nth-child(3) {
        animation-delay: .32s;
    }
    
    @keyframes bounce {
        from {
            transform: scaleX(1.25);
        }
        
        to {
            transform: translateY(-30px) scaleX(1);
        }
    }
</style>

<script>
    const makeLoading = () => {
        const wrapper = document.createElement("div");
        wrapper.classList.add("loading-cover");
        const loading = document.createElement("div");
        wrapper.appendChild(loading);
        loading.classList.add("loader", "absolute-centered");
        for (let i = 0; i < 3; i++) {
            loading.appendChild(document.createElement("div"));
        }

        return wrapper;
    }
</script>

<div class="loading-cover">
    <div class="loader absolute-centered">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
