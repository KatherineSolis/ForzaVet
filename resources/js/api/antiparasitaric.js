import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/antiparasitaric',
    method: 'get',
    params: query,
  });
}

export function createAntiparasitaric(data) {
  return request({
    url: '/antiparasitaric/create',
    method: 'post',
    data,
  });
}

export function updateAntiparasitaric(data) {
  return request({
    url: '/antiparasitaric/update/' + data.id,
    method: 'post',
    data,
  });
}
