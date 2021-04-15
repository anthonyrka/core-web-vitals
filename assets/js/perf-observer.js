try {
    let lcp;
    const po = new PerformanceObserver(entryList => {
        const entries = entryList.getEntries();
        const lastEntry = entries[entries.length -1];
        lcp = lastEntry.renderTime || lastEntry.loadTime;
        var e=document.getElementById("wp-admin-bar-lcp_toolbar_item_score");
        e.innerHTML = Math.round(lcp) + 'ms';

    })
    po.observe({ type: "largest-contentful-paint", buffered: true });
}
catch (e) {
    // The Largest Contentful Paint API is not supported by this browser
}
