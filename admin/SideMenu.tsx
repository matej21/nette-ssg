import * as React from 'react'
import { Menu } from '@contember/admin'

export const SideMenu = () => {
	return (
		<Menu>
			<Menu.Item>
				<Menu.Item title="Dashboard" to="dashboard"/>
				<Menu.Item title="Categories" to="categories"/>
				<Menu.Item title="Articles" to="articleList"/>
			</Menu.Item>
		</Menu>
	)
}
