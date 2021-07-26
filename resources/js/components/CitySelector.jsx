import React, {Fragment, useEffect, useState} from "react";
import {Listbox, Transition} from "@headlessui/react";
import {CheckIcon} from "@heroicons/react/solid";
import PropTypes from 'prop-types';

const cities = [
    {
        "country": "AU",
        "name": "Brisbane",
    },
    {
        "country": "AU",
        "name": "Melbourne",
    },
    {
        "country": "AU",
        "name": "Sydney",
    },
    {
        "country": "AU",
        "name": "Adelaide",
    },
    {
        "country": "AU",
        "name": "Perth",
    },
    {
        "country": "AU",
        "name": "Ipswich",
    },
    {
        "country": "AU",
        "name": "Gold coast",
    },
    {
        "country": "AU",
        "name": "Sunshine Coast",
    },
]

function CitySelector(props) {
    const [selected, setSelected] = useState(cities[0])

    useEffect(() => {
        props.onSelect(selected);
    }, [selected])

    const generateOptions = (cities) => {
        return <Listbox.Options
            className="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            {cities.map((city, cityId) => (
                <Listbox.Option
                    key={cityId}
                    className={({active}) =>
                        `${active ? 'text-amber-900 bg-amber-100' : 'text-gray-900'} cursor-default select-none relative py-2 pl-10 pr-4`
                    }
                    value={city}>
                    {({selected, active}) => (
                        <>
                            <span
                                className={`${
                                    selected ? 'font-medium' : 'font-normal'
                                } block truncate`}>
                              {city.name}
                            </span>
                            {selected ? (
                                <span
                                    className={`${
                                        active ? 'text-amber-600' : 'text-amber-600'
                                    }
                                absolute inset-y-0 left-0 flex items-center pl-3`}>
                                <CheckIcon className="w-5 h-5" aria-hidden="true"/>
                            </span>
                            ) : null}
                        </>
                    )}
                </Listbox.Option>
            ))}
        </Listbox.Options>
    }

    return (
        <div className="w-72">
            <Listbox value={selected} onChange={setSelected}>
                <div className="relative mt-1">
                    <Listbox.Button
                        className="relative w-full py-2 pl-3 pr-10 text-left bg-white rounded-lg shadow-md cursor-default focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white focus-visible:ring-offset-orange-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500 sm:text-sm">
                        <span className="block truncate">{selected.name}</span>
                    </Listbox.Button>
                    <Transition
                        as={Fragment}
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        {generateOptions(cities)}
                    </Transition>
                </div>
            </Listbox>
        </div>
    );
}

export default CitySelector;

CitySelector.propTypes = {
    onSelect: PropTypes.func
}
