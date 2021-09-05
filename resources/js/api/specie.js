import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/species',
    method: 'get',
    params: query,
  });
}

export function createSpecie(data) {
  return request({
    url: '/specie/create',
    method: 'post',
    data,
  });
}

export function updateSpecie(data) {
  return request({
    url: '/specie/update/' + data.id,
    method: 'post',
    data,
  });
}
