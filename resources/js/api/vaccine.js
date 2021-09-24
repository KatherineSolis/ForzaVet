import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/vaccines',
    method: 'get',
    params: query,
  });
}

export function createVaccine(data) {
  return request({
    url: '/vaccine/create',
    method: 'post',
    data,
  });
}

export function updateVaccine(data) {
  return request({
    url: '/vaccine/update/' + data.id,
    method: 'post',
    data,
  });
}
