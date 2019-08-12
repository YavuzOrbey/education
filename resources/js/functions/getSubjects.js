const getSubjects = () =>
    new Promise((resolves, rejects) => {
        const api = `/api/subjects`;
        const request = new XMLHttpRequest();
        request.open("GET", api);
        request.onload = () =>
            request.status === 200
                ? resolves(JSON.parse(request.response))
                : rejects(Error(request.statusText));
        request.onerror = err => rejects(err);
        request.send();
    });

export default getSubjects;
