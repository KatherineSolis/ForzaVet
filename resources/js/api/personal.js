import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/personal',
    method: 'get',
    params: query,
  });
}

export function createPersonal(data) {
  return request({
    url: '/personal/create',
    method: 'post',
    data,
  });
}

export function updatePersonal(data) {
  return request({
    url: '/personal/update/' + data.id,
    method: 'post',
    data,
  });
}
