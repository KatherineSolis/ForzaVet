import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/category',
    method: 'get',
    params: query,
  });
}

export function createCategory(data) {
  return request({
    url: '/category/create',
    method: 'post',
    data,
  });
}

export function updateCategory(data) {
  return request({
    url: '/category/update/' + data.id,
    method: 'post',
    data,
  });
}
