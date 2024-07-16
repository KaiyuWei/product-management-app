import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import 'react-tabs/style/react-tabs.css';

export default function DashboardTabs ({tabs}) {
    const tabsInArray = Object.entries(tabs);

    return (
        <Tabs>
            <TabList>
                {tabsInArray.map(([key, value]) => <Tab>{key}</Tab>)}
            </TabList>
            {tabsInArray.map(([key, value]) => <TabPanel>{value}</TabPanel>)}
        </Tabs>
    );
}