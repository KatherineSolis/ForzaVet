import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/productos',
    method: 'get',
    params: query,
  });
}

export function createProduct(data) {
  return request({
    url: '/productos/create',
    method: 'post',
    data,
  });
}

export function updateProdut(data) {
  return request({
    url: '/productos/update/' + data.id,
    method: 'post',
    data,
  });
}
