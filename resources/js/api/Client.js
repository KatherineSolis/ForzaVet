import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/clients',
    method: 'get',
    params: query,
  });
}

export function createClient(data) {
  return request({
    url: '/client/create',
    method: 'post',
    data,
  });
}

export function updateClient(data) {
  return request({
    url: '/client/update/' + data.id,
    method: 'post',
    data,
  });
}
