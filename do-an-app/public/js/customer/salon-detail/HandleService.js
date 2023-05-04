export function getServicesByIds(services, ids) {
    return services.filter(service => ids.includes(service.service_id));
}

export function getTotalPrice(services) {
    return services.reduce((total, service) => total + service.price, 0);
}

export function removeService(services, serviceID) {
    return services.filter(service => service.service_id != serviceID);
}

export function getAllServiceIDs(services) {
    return services.map(service => service.service_id);
}

export function findIndexes(ServiceA, ServiceB) {
    var setServiceB = new Set(ServiceB);
    var indexes = [];

    for (var i = 0; i < ServiceA.length; i++) {
        if (setServiceB.has(ServiceA[i])) {
            indexes.push(i);
        }
    }

    return indexes;
}


