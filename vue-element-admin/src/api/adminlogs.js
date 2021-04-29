import request from '@/utils/request'

export function getList(params) {
    return request({
        url: 'admin_logs',
        method: 'get',
        params
    })
}

export function setDel(data) {
    return request({
        url: `/admin_logs/delete`,
        method: 'delete',
        data
    })
}
