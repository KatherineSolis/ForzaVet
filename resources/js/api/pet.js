import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/pets',
    method: 'get',
    params: query,
  });
}

export function createPet(data) {
  return request({
    url: '/pet/create',
    method: 'post',
    data,
  });
}

export function updatePet(data) {
  return request({
    url: '/pet/update/' + data.id,
    method: 'post',
    data,
  });
}

export function ListClient() {
  return request({
    url: '/pet/client',
    method: 'get',
  });
}

export function getPet(data) {
  return request({
    url: '/pet/consultar/' + data,
    method: 'post',
    data,
  });
}
